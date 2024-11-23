<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header" style="height: 80px;">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 text-md-start text-center mb-2 mb-md-0">
                        <h3>Iniciar Chat</h3>
                    </div>
                    <div class="col-12 col-md-6 text-md-end text-center mb-2 mb-md-0">
                        <a class="btn" data-toggle="tooltip" title="Transferir para outro atendente">
                            <i style="color:#87CEFA;" class="bi bi-person-fill-gear h2"></i>
                            <p><small>Tranferir para outro antendente</small></p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div v-if="loading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <section v-else class="message-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="chat-area">
                                    <!-- chatlist -->
                                    <div class="chatlist">
                                        <div class="modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <h3>Atendentes</h3>
                                                <div class="modal-body">
                                                    <!-- chat-list -->
                                                    <div class="chat-lists">
                                                        <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="Open"
                                                                role="tabpanel" aria-labelledby="Open-tab">
                                                                <!-- chat-list -->
                                                                <div class="chat-list">
                                                                    <a href="#" class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <img class="img-fluid"
                                                                                src="https://mehedihtml.com/chatbox/assets/img/user.png"
                                                                                alt="user img">
                                                                            <span class="active"></span>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-3">
                                                                            <h3>Mehedi Hasan</h3>
                                                                            <p>front end developer</p>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chatbox">
                                        <div class="modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="msg-head">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h3>Cliente</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <ul class="moreoption">
                                                                <li class="navbar nav-item dropdown">
                                                                    <a class="nav-link dropdown-toggle" href="#"
                                                                        role="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false"><i
                                                                            class="fa fa-ellipsis-v"
                                                                            aria-hidden="true"></i></a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#">Action</a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#">Another
                                                                                action</a></li>
                                                                        <li>
                                                                            <hr class="dropdown-divider">
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#">Something
                                                                                else here</a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="modal-body">
                                                    <div class="msg-body">
                                                        <ul>
                                                            <li class="sender">
                                                                <p> Hey, Are you there? </p>
                                                                <span class="time">10:06 am</span>
                                                            </li>
                                                            <li class="sender">
                                                                <p> Hey, Are you there? </p>
                                                                <span class="time">10:16 am</span>
                                                            </li>
                                                            <li class="repaly">
                                                                <p>yes!</p>
                                                                <span class="time">10:20 am</span>
                                                            </li>
                                                            <li class="sender">
                                                                <p> Hey, Are you there? </p>
                                                                <span class="time">10:26 am</span>
                                                            </li>
                                                            <li class="sender">
                                                                <p> Hey, Are you there? </p>
                                                                <span class="time">10:32 am</span>
                                                            </li>
                                                            <li class="repaly">
                                                                <p>How are you?</p>
                                                                <span class="time">10:35 am</span>
                                                            </li>
                                                            <li>
                                                                <div class="divider">
                                                                    <h6>Today</h6>
                                                                </div>
                                                            </li>

                                                            <li class="repaly">
                                                                <p> yes, tell me</p>
                                                                <span class="time">10:36 am</span>
                                                            </li>
                                                            <li class="repaly">
                                                                <p>yes... on it</p>
                                                                <span class="time">junt now</span>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="send-box">
                                                    <form action="">
                                                        <input type="text" class="form-control" aria-label="message…"
                                                            placeholder="Write message…">

                                                        <button type="button"><i class="fa fa-paper-plane"
                                                                aria-hidden="true"></i> Send</button>
                                                    </form>

                                                    <div class="send-btns">
                                                        <div class="attach">
                                                            <div class="button-wrapper">
                                                                <span class="label">
                                                                    <img class="img-fluid"
                                                                        src="https://mehedihtml.com/chatbox/assets/img/upload.svg"
                                                                        alt="image title"> attached file
                                                                </span><input type="file" name="upload" id="upload"
                                                                    class="upload-box" placeholder="Upload File"
                                                                    aria-label="Upload File">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import dayjs from 'dayjs';

export default {
    data() {
        return {
            chats: {
                data: [],
                links: []
            },
            searchFilter: '',
            alertStatus: null,
            msg: [],
            loading: null,
        };
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
        }
    }
}
</script>
<style></style>