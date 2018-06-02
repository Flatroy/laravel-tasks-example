<template>
    <div v-show="this.visible" v-bind:class="{'task_done': current.is_done}"
         class="card mb-4">

        <div class="card-header d-inline-flex align-items-center justify-content-between">
            <div>{{ current.name }}</div>
            <div class="badge badge-success" @click="changeStatus">
                <span v-if="current.is_done">Completed</span>
                <span v-else="">Not completed</span>
            </div>
        </div>
        <div class="card-body">
            <div>{{ current.description }}</div>
            <div>Added by: {{ current.created_at | formatDate}}</div>
            <div v-if="current.finished_at">
                Finished by: {{ current.finished_at | formatDate}}
            </div>
            <hr/>
            <div class="d-flex justify-content-end btn-group flex-wrap">
                <button v-if="!current.is_done"
                        @click="changeStatus"
                        :disabled="btn.success"
                        class="btn btn-success">
                    <i class="fa fa-btn fa-check-circle"></i> Ready
                </button>
                <button v-else=""
                        @click="changeStatus"
                        :disabled="btn.success"
                        class="btn btn-info">Not ready
                </button>
                <a :href="'/task/' + current.id + '/'"
                   class="btn btn-secondary">
                    <i class="fa fa-btn fa-edit"></i> Edit
                </a>
                <button @click="deleteTask"
                        :disabled="btn.delete"
                        class="btn btn-danger">
                    <i class="fa fa-btn fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['task'],
        created() {
            this.current = this.task
        },
        data() {
            return {
                current: {},
                btn: {
                    delete: false,
                    status: false
                },
                visible: true
            }
        },
        methods: {
            changeStatus() {
                this.btn.status = true
                axios.patch('/task/' + this.task.id + '/').then(response => {
                    this.btn.status = false
                    this.current = response.data.task
                    console.log(response.data.task.is_done)
                    if (response.data.task.finished_at) {
                        this.current.finished_at = response.data.task.finished_at.date
                    }
                }).catch(e => {
                    this.btn.status = false
                    console.log(e)
                })
            },
            deleteTask() {
                this.btn.delete = true
                axios.delete('/task/' + this.task.id + '/').then(response => {
                    this.btn.delete = false
                    this.visible = false
                }).catch(e => {
                    this.btn.status = false
                    console.log(e)
                })
            }
        }
    }
</script>

<style lang="scss" scoped="">
    .badge-success {
        cursor: pointer;
    }
    .task_done {
        background: rgba(green, .15);
    }
</style>