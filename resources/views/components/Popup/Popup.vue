<script>
import PopupHeader from './PopupHeader.vue';

export default {
    components: {
        PopupHeader
    },

    props: {
        width: {
            type: String,
            default: '100%'
        },
        height: {
            type: String,
            default: '100%'
        },
        size: {
            type: String,
            default: '100%'
        },
        classWrapper: {
            type: [String, Function, Array],
            default: ''
        },

        position: {
            type: [String, Function],
            default: 'center'
        },

        onClose: {
            type: Function,
            default: () => {}
        },

        hasResize: {
            type: Boolean,
            default: true
        }
    },

    data() {
        return {
            isDragging: false,
            isResizing: false,
            isFullScreen: false,

            initialWidth: this.size !== '100%' ? this.size : this.width,
            initialHeight: this.size !== '100%' ? this.size : this.height,

            currentWidth: this.size !== '100%' ? this.size : this.width,
            currentHeight: this.size !== '100%' ? this.size : this.height,

            currentX: 0,
            currentY: 0,

            mouseDownX: 0,
            mouseDownY: 0,

            // RESIZE
            resizeDirection: null,

            resizeStartX: 0,
            resizeStartY: 0,

            resizeStartWidth: 0,
            resizeStartHeight: 0,

            resizeStartLeft: 0,
            resizeStartTop: 0,
        }
    },

    computed: {
        popupClass() {
            let classes = [
                this.isDragging ? 'border-2 border-(--popup-border-dragging-color)' : '',
                this.isFullScreen ? 'size-full! left-0! top-0! rounded-none!' : ''
            ]

            if (typeof this.classWrapper === 'string')
                return classes.concat(this.classWrapper)

            if (typeof this.classWrapper === 'function') {
                if (typeof this.classWrapper() !== 'string') {
                    console.error('значение функции classWrapper должно быть типа string')
                    return
                }

                const popup = this.$refs.popup

                return classes.concat(this.classWrapper(popup))
            }

            if (Array.isArray(this.classWrapper)) {
                return classes.concat(this.classWrapper.join(' '))
            }

            return classes
        },

        popupStyle() {
            return {
                width: this.currentWidth,
                height: this.currentHeight,
                left: this.currentX,
                top: this.currentY
            }
        },
    },

    methods: {
        fullScreenClickHandler() {
            if (!this.hasResize)
                return

            this.isFullScreen = !this.isFullScreen
        },

        setPosition() {
            this.$nextTick(() => {
                const popup = this.$refs.popup


                if (this.position === 'top') {
                    this.currentX = (window.innerWidth - popup.offsetWidth) / 2 + 'px'
                    this.currentY = 0
                }

                else if (this.position === 'left') {
                    this.currentX = 0
                    this.currentY = (window.innerHeight - popup.offsetHeight) / 2 + 'px'
                }

                else if (this.position === 'bottom') {
                    this.currentX = (window.innerWidth - popup.offsetWidth) / 2 + 'px'
                    this.currentY = window.innerHeight - popup.offsetHeight + 'px'
                }

                else if (this.position === 'right') {
                    this.currentX = window.innerWidth - popup.offsetWidth + 'px'
                    this.currentY = (window.innerHeight - popup.offsetHeight) / 2 + 'px'
                }

                else if (typeof this.position === 'function') {
                    const position = this.position(popup)

                    if (typeof position !== 'object' ) {
                        console.error('значение функции position должно быть типа object')
                        return
                    }

                    this.currentX = position.left ?? (window.innerWidth - popup.offsetWidth) / 2 + 'px'
                    this.currentY = position.top ?? (window.innerHeight - popup.offsetHeight) / 2 + 'px'
                }

                else {
                    this.currentX = (window.innerWidth - popup.offsetWidth) / 2 + 'px'
                    this.currentY = (window.innerHeight - popup.offsetHeight) / 2 + 'px'
                }

                fixOverflow(popup)
            })
        },

        startDrag(event) {
            const popupRef = this.$refs.popup
            const popupRect = popupRef.getBoundingClientRect()

            const mouseX = event.clientX
            const mouseY = event.clientY

            // расстояние от левой части попапа до курсора мыши при нажатии
            // расстояние от верхней части попапа до курсора мыши при нажатии
            this.mouseDownX = mouseX - popupRect.x
            this.mouseDownY = mouseY - popupRect.y

            // Сначала фиксируем текущее положение popup
            this.currentX = popupRect.left + 'px'
            this.currentY = popupRect.top + 'px'

            window.addEventListener('mousemove', this.onDragging)
            window.addEventListener('mouseup', this.stopDrag)

            this.isDragging = true
        },

        stopDrag(event) {
            window.removeEventListener('mousemove', this.onDragging)
            window.removeEventListener('mouseup', this.stopDrag)

            this.isDragging = false
        },

        onDragging(event) {
            if (this.isDragging){
                const mouseX = event.clientX
                const mouseY = event.clientY

                this.currentX = mouseX - this.mouseDownX + 'px'
                this.currentY = mouseY - this.mouseDownY + 'px'
            }

            return
        },

        // RESIZE
        startResize(event, direction) {
            if (!this.hasResize)
                return

            event.preventDefault()
            event.stopPropagation()

            this.resizeDirection = direction.toLowerCase()

            const rect = this.$refs.popup.getBoundingClientRect()

            this.isResizing = true

            this.resizeStartX = event.clientX
            this.resizeStartY = event.clientY

            this.resizeStartWidth = rect.width
            this.resizeStartHeight = rect.height

            this.resizeStartLeft = rect.left
            this.resizeStartTop = rect.top

            window.addEventListener('mousemove', this.onResize)
            window.addEventListener('mouseup', this.stopResize)
        },

        onResize(event) {
            if (!this.isResizing)
                return

            const dx = event.clientX - this.resizeStartX
            const dy = event.clientY - this.resizeStartY

            const minWidth = 250
            const minHeight = 150

            let width = this.resizeStartWidth
            let height = this.resizeStartHeight

            let left = this.resizeStartLeft
            let top = this.resizeStartTop

            // горизонталь
            if (this.resizeDirection.includes('right'))
                width = this.resizeStartWidth + dx

            if (this.resizeDirection.includes('left')) {
                width = this.resizeStartWidth - dx
                left = this.resizeStartLeft + dx
            }

            // вертикаль
            if (this.resizeDirection.includes('bottom'))
                height = this.resizeStartHeight + dy

            if (this.resizeDirection.includes('top')) {
                height = this.resizeStartHeight - dy
                top = this.resizeStartTop + dy
            }

            // ограничение ширины слева
            if (width < minWidth) {
                if (this.resizeDirection.includes('left')) {
                    left = this.resizeStartLeft + this.resizeStartWidth - minWidth
                }

                width = minWidth
            }

            // ограничение высоты сверху
            if (height < minHeight) {
                if (this.resizeDirection.includes('top')) {
                    top = this.resizeStartTop + this.resizeStartHeight - minHeight
                }

                height = minHeight
            }

            this.currentWidth = width + 'px'
            this.currentHeight = height + 'px'

            this.currentX = left + 'px'
            this.currentY = top + 'px'
        },

        stopResize() {
            this.isResizing = false

            window.removeEventListener('mousemove', this.onResize)
            window.removeEventListener('mouseup', this.stopResize)
        },
    },

    mounted() {
        this.setPosition()
    },

    beforeUnmount() {
        window.removeEventListener('mousemove', this.onDragging)
        window.removeEventListener('mouseup', this.stopDrag)
    },
}
</script>

<template>
    <div class="popup-wrapper fixed z-10000 inset-0 flex flex-col" :class="isDragging ? 'pointer-events-none select-none' : 'pointer-events-auto select-auto'">
        <div
            ref="popup"
            class="popup fixed rounded-xl drop-shadow-xl bg-(--popup-background-color) flex flex-col overflow-hidden border border-(--border-color) pointer-events-auto"
            :class="popupClass"
            :style="popupStyle"
            v-outsideClick="onClose"
            v-bind="$attrs"
        >
            <PopupHeader
                :on-close
                :on-full-screen="fullScreenClickHandler"
                :is-dragging
                :is-full-screen
                :has-resize
                @mousedown="startDrag"
            />

            <div class="w-full flex-1" :class="isDragging ? 'pointer-events-none select-none' : 'pointer-events-auto select-auto'">
                <slot />
            </div>

            <!-- RESIZE -->
            <template v-if="hasResize">
                <div
                    class="resize-top-handle absolute top-0 left-[12px] right-[12px] h-[8px] cursor-ns-resize"
                    @mousedown="startResize($event,'top')"
                />
                <div
                    class="resize-bottom-handle absolute bottom-0 left-[12px] right-[12px] h-[8px] cursor-ns-resize"
                    @mousedown="startResize($event,'bottom')"
                />
                <div
                    class="resize-left-handle absolute left-0 top-[12px] bottom-[12px] w-[8px] cursor-ew-resize"
                    @mousedown="startResize($event,'left')"
                />
                <div
                    class="resize-right-handle absolute right-0 top-[12px] bottom-[12px] w-[8px] cursor-ew-resize"
                    @mousedown="startResize($event,'right')"
                />
                <div
                    class="resize-top-left-handle absolute top-0 left-0 w-[12px] h-[12px] cursor-nwse-resize"
                    @mousedown="startResize($event,'topLeft')"
                />
                <div
                    class="resize-top-right-handle absolute top-0 right-0 w-[12px] h-[12px] cursor-nesw-resize"
                    @mousedown="startResize($event,'topRight')"
                />
                <div
                    class="resize-bottom-left-handle absolute bottom-0 left-0 w-[12px] h-[12px] cursor-nesw-resize"
                    @mousedown="startResize($event,'bottomLeft')"
                />
                <div
                    class="resize-bottom-right-handle absolute bottom-0 right-0 w-[12px] h-[12px] cursor-nwse-resize"
                    @mousedown="startResize($event,'bottomRight')"
                />
            </template>

        </div>
    </div>
</template>

<stype lang="sass" scoped>
</stype>
