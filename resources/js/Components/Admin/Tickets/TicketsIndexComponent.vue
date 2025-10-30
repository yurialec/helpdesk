<template>
    <div class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-md-3 col-12">
                    <h5 class="mb-0">Tickets</h5>
                </div>

                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" v-model="searchFilter"
                            placeholder="Buscar por protocolo, empresa ou assunto..." @keyup.enter="search" />
                        <button type="button" class="btn btn-sm btn-primary" @click="search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-3 col-12 text-md-end">
                    <a :href="urlCreate" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-2">
            <div class="table-responsive" v-if="tickets.data.length > 0">
                <table class="table table-sm table-hover align-middle text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Protocolo</th>
                            <th>Empresa</th>
                            <th>Sistema</th>
                            <th>Assunto</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th>Prazo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ticket in tickets.data" :key="ticket.id">
                            <td>{{ ticket.id }}</td>
                            <td>{{ ticket.protocol }}</td>
                            <td>{{ ticket.company?.name }}</td>
                            <td>{{ ticket.system?.name }}</td>
                            <td class="text-truncate" style="max-width: 200px;" :title="ticket.subject">
                                {{ ticket.subject }}
                            </td>
                            <td>
                                <span class="badge" :style="{ backgroundColor: ticket.priority?.color_code }">
                                    {{ ticket.priority?.name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge" :style="{ backgroundColor: ticket.status?.color_code }">
                                    {{ ticket.status?.name }}
                                </span>
                            </td>
                            <td>{{ formatDate(ticket.due_date) }}</td>
                            <td>
                                <a :href="urlEdit.replace('_id', ticket.id)" class="btn btn-sm btn-outline-primary me-1"
                                    title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <!-- <button class="btn btn-sm btn-outline-secondary" title="Visualizar"
                                    @click="viewTicket(ticket)">
                                    <i class="bi bi-eye"></i>
                                </button> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="text-center text-muted py-3">
                <i class="bi bi-inbox"></i> Nenhum ticket encontrado.
            </div>
        </div>

        <div class="card-footer py-2" v-if="tickets.links.length > 0">
            <nav>
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    <li v-for="(link, i) in tickets.links" :key="i"
                        :class="['page-item', { active: link.active, disabled: !link.url }]">
                        <a class="page-link" href="#" v-html="link.label" @click.prevent="pagination(link.url)"></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        urlCreate: String,
        urlEdit: String,
    },
    data() {
        return {
            searchFilter: '',
            loading: false,
            tickets: {
                data: [],
                links: []
            },
        };
    },
    mounted() {
        this.getTickets();
    },
    methods: {
        search() {
            this.getTickets('admin/tickets/list?search=' + this.searchFilter);
        },
        pagination(url) {
            if (url) this.getTickets(url);
        },
        getTickets(url = 'admin/tickets/list') {
            this.loading = true;
            axios
                .get(url)
                .then(response => {
                    this.tickets = response.data.items;
                })
                .catch(error => {
                    console.error(error);
                    this.alertDanger('Erro ao carregar tickets.');
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        formatDate(dateStr) {
            if (!dateStr) return '—';
            const date = new Date(dateStr);
            return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
        },
        viewTicket(ticket) {
            alert(`Ticket ${ticket.protocol}\n\nAssunto: ${ticket.subject}\nEmpresa: ${ticket.company?.name}`);
        },
    },
};
</script>
