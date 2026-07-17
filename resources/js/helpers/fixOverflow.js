// HACK сделать код чище
export function fixOverflow(el) {
    if (typeof el !== 'object') {
        console.error('Аргумент не является объектом!')
        return
    }

    el.style.maxHeight      = 'none'
    el.style.minHeight      = 'none'

    let isOverflow = false
    const rect = el.getBoundingClientRect();

    const overflowBottom = rect.bottom > window.innerHeight;
    const overflowRight  = rect.right > window.innerWidth;

    // Если вылез снизу за экран
    if(overflowBottom) {
        el.style.top    = 'auto'
        el.style.bottom = '100%'

        isOverflow = true
    }
    // Другие
    // .....

    el.style.maxHeight = null
    el.style.minHeight = null

    void el.offsetHeight

    return isOverflow
}

window.fixOverflow = fixOverflow;
