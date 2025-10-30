<template>
    <div class="container-fluid px-2" v-loading="{ show: loading }">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar Ticket</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Protocolo</label>
                                <input type="text" class="form-control" v-model="ticket.protocol" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Empresa</label>
                                <input type="text" class="form-control" v-model="ticket.company.name" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sistema</label>
                                <input type="text" class="form-control" v-model="ticket.system.name" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Assunto</label>
                                <input type="text" class="form-control" v-model="ticket.subject">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" rows="5" v-model="ticket.description"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" v-model="ticket.status_id">
                                        <option v-for="sts in status" :key="sts.id" :value="sts.id">
                                            {{ sts.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prioridade</label>
                                    <select class="form-select" v-model="ticket.priority_id" required>
                                        <option v-for="priority in priorities" :key="priority.id" :value="priority.id">
                                            {{ priority.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prazo</label>
                                <input type="datetime-local" class="form-control" v-model="ticket.due_date" disabled>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm" :disabled="loading">
                                    <span v-if="loading"><i class="bi bi-hourglass-split me-1"></i> Salvando...</span>
                                    <span v-else>Atualizar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: [String, Number],
        urlIndex: String,
    },
    data() {
        return {
            loading: false,
            ticket: {
                company: {},
                system: {},
                status: {},
                priority: {}
            },
            priorities: {},
            status: {}
        };
    },
    mounted() {
        this.find(this.id);
        this.listPriorities();
        this.listStatus();
    },
    methods: {
        find(id) {
            this.loading = true;
            axios.get(`/admin/tickets/find/${id}`)
                .then(response => {
                    this.ticket = response.data.item;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        listPriorities() {
            this.loading = true;
            axios.get('/admin/tickets/list-priorities/')
                .then(response => {
                    this.priorities = response.data.item;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        listStatus() {
            this.loading = true;
            axios.get('/admin/tickets/list-status/')
                .then(response => {
                    this.status = response.data.item;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        save() {
            this.loading = true;
            axios.put(`/admin/tickets/update/${this.ticket.id}`, this.ticket)
                .then(response => {
                    this.alertSuccess('Ticket atualizado com sucesso!');
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>
