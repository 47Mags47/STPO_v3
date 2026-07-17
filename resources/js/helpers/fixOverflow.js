// HACK сделать код чище
export function fixOverflow(el) {
    if (typeof el !== 'object') {
        console.error('Аргумент не является объектом!')
        return
    }

    el.style.maxHeight      = 'none'
    el.style.minHeight      = 'none'
    el.style.display        = 'flex'

    let isOverflow = false
    const rect = el.getBoundingClientRect();

    const overflowBottom = rect.bottom > window.innerHeight;
    const overflowRight  = rect.right > window.innerWidth;

    console.log(rect.bottom, window.innerHeight)
    // Если вылез снизу за экран
    if(overflowBottom) {
        el.style.top    = 'auto'
        el.style.bottom = '100%'

        isOverflow = true
    }
    if(overflowRight) {
        el.style.left    = 'auto'
        el.style.right = '0'

        isOverflow = true
    }
    // Другие
    // .....

    el.style.maxHeight = null
    el.style.minHeight = null
    el.style.display   = null

    void el.offsetHeight

    return isOverflow
}

window.fixOverflow = fixOverflow;
