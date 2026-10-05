export const silentRoutes = [
    // CHAT
    {
        url:    route('chat.messages.index',    { chat: ':chat' }).replace(':chat', '\\d+'),
        method: 'post'
    },

    // APPEALS
    {
        url:    route('appeal.accept',          { appeal: ':appeal' }).replace(':appeal', '\\d+'),
        method: 'post'
    },
    {
        url:    route('appeal.close',           { appeal: ':appeal' }).replace(':appeal', '\\d+'),
        method: 'post'
    },
    {
        url:    route('appeal.reaccept',        { appeal: ':appeal' }).replace(':appeal', '\\d+'),
        method: 'post'
    },
]
