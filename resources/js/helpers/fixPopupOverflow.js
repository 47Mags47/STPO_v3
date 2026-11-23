// HACK сделать код чище
export function fixPopupOverflow(el) {
    if (typeof el !== 'object') {
        console.error('Аргумент не является объектом!')
        return
    }

    el.style.maxHeight      = 'none'
    el.style.minHeight      = 'none'
    el.style.display        = 'flex'

    let isOverflow = false
    let side = null
    const rect = el.getBoundingClientRect();

    const overflowBottom = rect.bottom > window.innerHeight;
    const overflowRight  = rect.right > window.innerWidth;

    // Если вылез снизу за экран
    if (overflowBottom) {
        el.style.top = 'auto';
        el.style.bottom = '10px';
        isOverflow = true;
        side = 'bottom'
    }
    if(overflowRight) {
        el.style.left    = 'auto'
        el.style.right = '10px'

        isOverflow = true
        side = 'right'
    }
    // Другие
    // .....

    el.style.maxHeight = null
    el.style.minHeight = null
    el.style.display   = null

    void el.offsetHeight

    return {
        side: side,
        state: isOverflow
    }
}

window.fixPopupOverflow = fixPopupOverflow;
