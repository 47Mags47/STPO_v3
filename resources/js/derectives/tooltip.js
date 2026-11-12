
import { createVNode, render } from 'vue';
import Tooltip from '../../views/components/Tooltip.vue';

const getText = (value) => typeof value === 'string'
    ? value
    : value?.text ?? '';

export const tooltip = {
    mounted(el, binding) {
        const container = document.createElement('div');
        container.style.display = 'contents';
        document.body.appendChild(container);

        const text = getText(binding.value);

        render(createVNode(Tooltip, { text }), container);

        const tooltip = container.firstElementChild;

        if (!tooltip) {
            container.remove();
            return;
        }

        const instance = {
            container,
            tooltip,
            text,
            lastEvent: null,
        };

        const move = (event) => {
            instance.lastEvent = event;

            if (!instance.text) return;

            const rect = tooltip.getBoundingClientRect();
            const offset = 14;
            const padding = 8;

            let left = event.clientX + offset;
            let top = event.clientY + offset;

            if (left + rect.width > window.innerWidth - padding)
                left = event.clientX - rect.width - offset;

            if (top + rect.height > window.innerHeight - padding)
                top = event.clientY - rect.height - offset;

            left = Math.max(padding, Math.min(left, window.innerWidth - rect.width - padding));
            top = Math.max(padding, Math.min(top, window.innerHeight - rect.height - padding));

            tooltip.style.left = `${left}px`;
            tooltip.style.top = `${top}px`;
        };

        const show = (event) => {
            if (!instance.text) return;

            move(event);
            tooltip.classList.add('visible');
        };

        const hide = () => {
            tooltip.classList.remove('visible');
        };

        el.addEventListener('mouseenter', show);
        el.addEventListener('mousemove', move);
        el.addEventListener('mouseleave', hide);

        Object.assign(instance, { show, move, hide });

        el._tooltip = instance;
    },

    updated(el, binding) {
        const instance = el._tooltip;
        if (!instance) return;

        const text = getText(binding.value);

        instance.text = text;

        render(createVNode(Tooltip, { text }), instance.container);

        if (!text) {
            instance.hide();
            return;
        }

        if (instance.tooltip.classList.contains('visible') && instance.lastEvent) {
            instance.move(instance.lastEvent);
        }
    },

    unmounted(el) {
        const instance = el._tooltip;
        if (!instance) return;

        el.removeEventListener('mouseenter', instance.show);
        el.removeEventListener('mousemove', instance.move);
        el.removeEventListener('mouseleave', instance.hide);

        render(null, instance.container);
        instance.container.remove();

        delete el._tooltip;
    },
};
