export let outsideClick = {
    mounted: function (el, binding, vnode) {
        if (binding.value === null) return;

        el.clickOutsideEvent = function (event) {
            if (!(el == event.target || el.contains(event.target))) {
                binding.value(event);
            }
        };
        document.body.addEventListener("click", el.clickOutsideEvent);
    },
    unmounted: function (el) {
        document.body.removeEventListener("click", el.clickOutsideEvent);
    },
};
