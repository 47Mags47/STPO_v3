// EVENTS:
// onAllFileUploaded
// onFileUploaded
// onError
// onChunkUploaded

export async function uploadFiles(fileList, events = {}) {
    const { onAllFileUploaded } = events;
    const defaultonAllFileUploaded = () => {};

    const results = await runWithLimit(fileList, 3, (file) =>
        uploadFile(file, events),
    );

    (onAllFileUploaded || defaultonAllFileUploaded)();

    return results;
}

export async function uploadFile(file, events = {}) {
    // инициализация событий
    const onFileUploaded = 'onFileUploaded' in events
        ? events.onFileUploaded
        : () => {}

    try {
        const response = await axios.post(route("upload.startUpload"), {
            origin_name: file.name,
            file_size: file.size,
        });

        const chunkSize = response.data.data.config.chunkSize;
        const chunks = response.data.data.chunks;

        const results = await runWithLimit(chunks, 5, (chunk) => {
            const content = file.slice(
                (chunk.npp - 1) * chunkSize,
                chunk.npp * chunkSize,
            );
            return uploadChunk(chunk, content, 0, events);
        });

        if (results.every((res) => res === true)) {
            const result = {
                file: file,
                info: {
                    id: response.data.data.id,
                    uploaded: true
                }
            }
            onFileUploaded(result)

            return result
        } else {
            // Если хоть один чанк упал — возвращаем false
            return false;
        }
    } catch (error) {
        console.error("Ошибка при старте загрузки файла:", error);
        return false;
    }
}

async function uploadChunk(chunk, content, attempt = 0, events = {}) {
    // инициализация событий
    const onError = 'onError' in events
        ? events.onError
        : () => {}

    const onChunkUploaded = 'onChunkUploaded' in events
        ? events.onChunkUploaded
        : () => {}

    if (attempt === 3) {
        onError("Достигнуто максимальное число попыток загрузки чанка");
        return false;
    }

    try {
        await axios.postForm(route("upload.writeChunk", { chunk: chunk.id }), {
            file: content,
        });

        onChunkUploaded(chunk);

        return true;
    } catch (error) {
        return await uploadChunk(chunk, content, attempt + 1, events);
    }
}

async function runWithLimit(items, limit, taskFn) {
    const results = new Array(items.length);
    let index = 0;

    async function worker() {
        while (index < items.length) {
            const current = index++;
            results[current] = await taskFn(items[current], current);
        }
    }

    const workers = Array.from({ length: Math.min(limit, items.length) }, () =>
        worker(),
    );
    await Promise.all(workers);
    return results;
}
