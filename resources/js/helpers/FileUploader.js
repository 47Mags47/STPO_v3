export default class FileUploader {
    #events;

    constructor() {
        this.#events = {
            onAllFileUploaded: [],
            onFileUploaded: [],
            onError: [],
            onChunkUploaded: [],
        };
    }

    onAllFileUploaded(callback) {
        this.#events.onAllFileUploaded.push(callback);
    }

    onFileUploaded(callback) {
        this.#events.onFileUploaded.push(callback);
    }

    onError(callback) {
        this.#events.onError.push(callback);
    }

    onChunkUploaded(callback) {
        this.#events.onChunkUploaded.push(callback);
    }

    #emit(event, data) {
        this.#events[event]?.forEach(callback => callback(data));
    }

    async uploadFiles(fileList) {
        const results = await this.runWithLimit(
            fileList,
            3,
            file => this.uploadFile(file),
        );

        this.#emit('onAllFileUploaded', results);

        return results;
    }

    async uploadFile(file) {
        try {
            const response = await axios.post(route('upload.startUpload'), {
                origin_name: file.name,
                file_size: file.size,
            });

            const chunkSize = response.data.data.config.chunkSize;
            const chunks = response.data.data.chunks;

            const results = await this.runWithLimit(chunks, 5, chunk => {
                const content = file.slice(
                    (chunk.npp - 1) * chunkSize,
                    chunk.npp * chunkSize,
                );

                return this.uploadChunk(chunk, content);
            });

            if (results.every(res => res === true)) {
                const result = {
                    file,
                    info: {
                        id: response.data.data.id,
                        uploaded: true,
                    },
                };

                this.#emit('onFileUploaded', result);

                return result;
            }

            return false;
        } catch (error) {
            console.error('Ошибка при старте загрузки файла:', error);
            return false;
        }
    }

    async uploadChunk(chunk, content, attempt = 0) {
        if (attempt === 3) {
            this.#emit(
                'onError',
                'Достигнуто максимальное число попыток загрузки чанка',
            );

            return false;
        }

        try {
            await axios.postForm(
                route('upload.writeChunk', { chunk: chunk.id }),
                { file: content },
            );

            this.#emit('onChunkUploaded', chunk);

            return true;
        } catch (error) {
            return this.uploadChunk(chunk, content, attempt + 1);
        }
    }

    async runWithLimit(items, limit, taskFn) {
        const results = new Array(items.length);
        let index = 0;

        async function worker() {
            while (index < items.length) {
                const current = index++;
                results[current] = await taskFn(items[current], current);
            }
        }

        const workers = Array.from(
            { length: Math.min(limit, items.length) },
            () => worker(),
        );

        await Promise.all(workers);

        return results;
    }
}
