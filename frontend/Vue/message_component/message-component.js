
Vue.component('message' , {
    props: ['title', 'body'],
    template: `
    <article class="message" v-show="isVisible">
      <div class="message-header">
        <p>{{ title }}</p>
        <button type="button" @click="isVisible = false" class="close">x</button>
      </div>
      <div class="message-body">
        {{ body }}
      </div>
    </article>
    `,
    data() {
        return {
            isVisible : true,
        }
    }
})

new Vue({
    el : '#root'
})
