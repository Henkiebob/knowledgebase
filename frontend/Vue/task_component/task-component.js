
Vue.component('task-list' , {
    template: `
    <div>
        <v-for="task in tasks">
            {{ task.description }}
        </task>
    </div>
    `,
    data() {
        return {
            tasks: [
                { description: 'Laravel college maken', completed: true },
                { description: 'Afwassen', completed: true },
                { description: 'Jan Wessel schoppen', completed: false },
            ]
        }
    }
})

Vue.component('task' , {
    template: '<li><slot></slot></li>'
})


new Vue({
    el : '#root'
})
