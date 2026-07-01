function waitTransition(e) {
    return new Promise(resolve =>
        e.addEventListener('transitionend', () => resolve(true), { once: true })
    );
}

// HACK дописать хелпер фикса позиционирования,
// Если выходит за экран (сейчас работает только с элементами, у которых свойство fixed/absolute)
export async function fixOverflow(e) {
    if (typeof e !== 'object') {
        console.error('Аргумент не является объектом!')
        return
    }

    await waitTransition(e)

    const rect = e.getBoundingClientRect();

    let left = parseFloat(getComputedStyle(e).left) || 0;
    let top = parseFloat(getComputedStyle(e).top) || 0;

    const overflowRight = rect.right - window.innerWidth;
    const overflowBottom = rect.bottom - window.innerHeight;

    if (rect.left < 0) {
        e.style.left = `${left - rect.left}px`;
    }

    if (overflowRight > 0) {
        e.style.left = `${left - overflowRight}px`;
    }

    if (rect.top < 0) {
        e.style.top = `${top - rect.top}px`;
    }

    if (overflowBottom > 0) {
        e.style.top = `${top - overflowBottom}px`;
    }
}

window.fixOverflow = fixOverflow;
