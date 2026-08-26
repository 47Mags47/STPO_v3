import { usePage } from "@inertiajs/vue3";

const current_user__permissions = usePage().props?.current_user.data.permissions;

export function hasPermission(code) {
    if (typeof code !== 'string') {
        console.error('Тип параметра функции должен быть string')
        return false
    }

    return current_user__permissions?.some(permission => permission.code === code) ?? false
}

window.hasPermission = hasPermission;
