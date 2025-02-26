<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3 text-md-left text-center mb-2 mb-md-0">
                        <h3>Chat</h3>
                    </div>
                    <div class="col-12 col-md-6 text-center mb-2 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="searchFilter" />
                            <button type="button" class="btn btn-primary" @click="pesquisar()">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="loading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <table v-else class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Protocolo</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Status</th>
                            <th scope="col">Criado em</th>
                            <th scope="col">Atendente</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="chat in chats.data" :key="chat.id">
                            <td scope="row">{{ chat.protocol }}</td>
                            <td scope="row">{{ chat.client.name }}</td>
                            <td scope="row">
                                <span :class="chatStatusBadge(chat.status.name)">
                                    {{ chat.status.name }}
                                </span>
                            </td>
                            <td scope="row">{{ formatDate(chat.created_at) }}</td>
                            <td scope="row">{{ chat.user.name }}</td>
                            <td scope="row">
                                <a :href="urlViewChat.replace(':id', chat.id)" class="btn" data-toggle="tooltip"
                                    title="Iniciar Chat">
                                    <i style="color:green;" class="bi bi-chat-text"></i>
                                </a>
                                <button @click="transferir(chat)" data-bs-toggle="modal"
                                    data-bs-target="#modalTransferirChat" class="btn" data-toggle="tooltip"
                                    title="Transferir para outro atendente">
                                    <i style="color:#87CEFA;" class="bi bi-person-fill-gear"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li v-for="(link, key) in chats.links" :key="key" class="page-item"
                            :class="{ 'active': link.active }">
                            <a class="page-link" href="#" @click.prevent="pagination(link.url)" v-html="link.label"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTransferirChat" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div v-if="alertStatus === false" class="alert alert-danger alert-dismissible fade show"
                        role="alert">
                        <strong>Selecione o atendente!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-start">
                            <select class="form-select" v-model="selectedAttendant">
                                <option disabled value="">Selecione o novo atendente</option>
                                <option v-for="attendant in attendants" :key="attendant.id" :value="attendant.id">
                                    {{ attendant.name }}
                                </option>
                            </select>
                            <button class="btn btn-primary btn-sm ms-2"
                                @click="confirmarTransferencia">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
import dayjs from 'dayjs';
import { Modal } from 'bootstrap';

export default {
    props: {
        urlViewChat: String,
    },
    data() {
        return {
            chats: {
                data: [
                ],
                links: []
            },
            searchFilter: '',
            alertStatus: null,
            msg: [],
            loading: null,
            attendants: [],
            selectedAttendant: '',
            selectedChat: '',
        };
    },
    computed: {
        filteredAttendants() {
            if (!this.chatSelecionado) return this.attendants;
            return this.attendants.filter(attendant => attendant.id !== this.chatSelecionado.user.id);
        }
    },
    mounted() {
        this.getChats();
    },
    methods: {
        pesquisar() {
            this.getChats('admin/chat/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getChats(url);
            }
        },
        getChats(url = 'admin/chat/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.chats = response.data.chats;
                })
                .catch(errors => {

                }).finally(() => {
                    this.loading = false
                });
        },
        formatDate(date) {
            return dayjs(date).format('DD/MM/YYYY HH:mm:ss');
        },
        chatStatusBadge(status) {
            switch (status) {
                case 'Pendente':
                    return 'badge text-bg-warning';
                case 'Ativo':
                    return 'badge text-bg-success';
                case 'Finalizado':
                    return 'badge text-bg-secondary';
            }
        },
        transferir(chat) {
            this.listAttendants(chat);
            this.selectedChat = chat.id;
            this.alertStatus = null;
        },
        listAttendants(chat) {
            axios.get('admin/chat/attendants/list')
                .then(response => {
                    this.attendants = response.data.attendants.data
                        .filter(attendant => attendant.id !== chat.user.id);
                })
                .catch(errors => {
                    console.log(errors);
                }).finally(() => {
                    this.loading = false
                });
        },
        confirmarTransferencia() {
            if (!this.selectedAttendant) {
                this.alertStatus = false;
                return;
            }

            axios.post('admin/chat/transfer/' + this.selectedChat + '/' + this.selectedAttendant)
                .then(response => {
                    this.getChats();
                    this.selectedChat = null;
                    this.selectedAttendant = '';

                    const modal = Modal.getInstance(document.getElementById('modalTransferirChat'));
                    if (modal) {
                        modal.hide();
                    }
                })
                .catch(error => {
                    const modal = Modal.getInstance(document.getElementById('modalTransferirChat'));
                    if (modal) {
                        modal.hide();
                    }
                });
        }
    }
}
</script>