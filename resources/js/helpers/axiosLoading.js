import axios from 'axios';

let activeRequests = 0;

export const axiosLoading = {
    onStart: null,
    onFinish: null,
};

axios.interceptors.request.use(config => {
    activeRequests++;

    if (activeRequests === 1)
        axiosLoading.onStart?.();

    return config;
});

axios.interceptors.response.use(
    response => {
        finishRequest();
        return response;
    },
    error => {
        finishRequest();
        return Promise.reject(error);
    }
);

function finishRequest() {
    activeRequests = Math.max(0, activeRequests - 1);

    if (activeRequests === 0)
        axiosLoading.onFinish?.();
}
