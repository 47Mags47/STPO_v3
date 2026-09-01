export const silentRoutes = [
    // APPEALS
    {
        url:    route('appeal.messages.store',  { appeal: ':appeal' }).replace(':appeal', '\\d+'),
        method: 'post'
    },
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

    //
]
