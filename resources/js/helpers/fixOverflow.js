// HACK сделать код чище
export function fixOverflow(e) {
    if (typeof e !== 'object') {
        console.error('Аргумент не является объектом!')
        return
    }

    let isOverflow = false

    // начальные свойства для расчёта
    e.style.top           = '100%';
    e.style.bottom        = 'auto';
    e.style.maxHeight     = '250px'
    e.style.opacity       = '0'
    e.style.pointerEvents = 'none'
    e.style.transition    = 'none'
    e.style.border        = 'var(--input-border)'
    e.style.borderTop     = '0'

    // фиксим позицию (e раскрылся, но невидим + некликабелен)
    const rect           = e.getBoundingClientRect()
    const overflowBottom = rect.bottom - window.innerHeight

    // Если выходит за экран снизу
    if (overflowBottom > 0) {
        e.style.top    = 'auto'
        e.style.bottom = '100%'
        e.style.borderTop = 'var(--input-border)'
        e.style.borderBottom = '0'
        e.style.borderRadius = 'var(--input-border-radius) var(--input-border-radius) 0 0'
        isOverflow = true
    }
    // ..... Другие условия (сверху, справа, слева)

    // возвращаем элемент в изначальное состояние (closed)
    e.style.maxHeight     = '0'
    e.style.opacity       = '0'
    e.style.pointerEvents = 'none'

    // Чтобы был перерасчёт браузером
    e.offsetHeight

    // раскрываем список с анимацией
    e.style.transition    = 'max-height .4s ease, opacity .4s ease';
    e.style.opacity       = '1';
    e.style.pointerEvents = 'auto';
    e.style.maxHeight     = '250px';

    return isOverflow
}

window.fixOverflow = fixOverflow;
