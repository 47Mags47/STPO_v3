export const silentRoutes = [
    {
        url:    route('appeal.messages.store', { appeal: ':appeal' }).replace(':appeal', '\\d+'),
        method: 'post'
    }
]
