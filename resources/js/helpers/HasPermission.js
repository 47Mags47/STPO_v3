import { usePage } from "@inertiajs/vue3";

export function hasPermission(code) {
    if (typeof code !== 'string') {
        console.error('Тип параметра функции должен быть string')
        return false
    }

    const current_user = usePage().props.current_user.data;

    return current_user?.permissions?.some(permission => permission.code === code) ?? false
}

window.hasPermission = hasPermission;
