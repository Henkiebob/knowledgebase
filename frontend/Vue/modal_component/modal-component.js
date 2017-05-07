
Vue.component('modal' , {
    props: ['title', 'body'],
    template: `
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <slot></slot>
            </div>
        </div>
        <button class="modal-close" @click="$emit('close')"></button>
    </div>
    `,
    data() {
        return {
            isVisible : false,
        }
    }
})

new Vue({
    el : '#root',
    data: {
        isVisible: false
    }
})
