<template>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm rounded-3" v-loading="{ show: loading }">
                    <div class="card-body">

                        <!-- Botão Editar -->
                        <div class="row mb-4">
                            <div class="col-12 text-end">
                                <a :href="urlEdit" class="btn btn-success btn-sm px-3">
                                    Editar
                                </a>
                            </div>
                        </div>

                        <!-- Conteúdo Principal -->
                        <div class="row mb-4">
                            <div class="col-12 col-md-4">
                                <h6 class="fw-bold mb-2 border-start ps-2 text-primary">Conteúdo Principal</h6>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="mb-1">
                                    <strong>Título:</strong>
                                    <span>{{ main?.title }}</span>
                                </div>
                                <div>
                                    <strong>Texto:</strong>
                                    <span>{{ main?.text }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-top my-3"></div>

                        <!-- Sobre -->
                        <div class="row mb-4">
                            <div class="col-12 col-md-4">
                                <h6 class="fw-bold mb-2 border-start ps-2 text-primary">Sobre</h6>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="mb-1">
                                    <strong>Título:</strong>
                                    <span>{{ about?.title }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Descrição:</strong>
                                    <span>{{ about?.description }}</span>
                                </div>

                                <div v-if="about && about.image" class="mt-2">
                                    <strong>Imagem:</strong><br>
                                    <img class="d-block rounded shadow-sm mt-1" :src="`/storage/${about.image}`"
                                        width="200" height="200" style="object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <div class="border-top my-3"></div>

                        <!-- Contato -->
                        <div class="row mb-4">
                            <div class="col-12 col-md-4">
                                <h6 class="fw-bold mb-2 border-start ps-2 text-primary">Contato</h6>
                            </div>
                            <div class="col-12 col-md-8">
                                <dl class="row mb-2">
                                    <dt class="col-sm-4">Telefone:</dt>
                                    <dd class="col-sm-8">{{ contact?.phone }}</dd>

                                    <dt class="col-sm-4">E-mail:</dt>
                                    <dd class="col-sm-8">{{ contact?.email }}</dd>
                                </dl>

                                <dl class="row mb-2">
                                    <dt class="col-sm-4">Cidade:</dt>
                                    <dd class="col-sm-8">{{ contact?.city }}/{{ contact?.state }}</dd>

                                    <dt class="col-sm-4">Endereço:</dt>
                                    <dd class="col-sm-8">{{ contact?.address }}</dd>
                                </dl>

                                <dl class="row mb-2">
                                    <dt class="col-sm-4">CEP:</dt>
                                    <dd class="col-sm-8">{{ contact?.zipcode }}</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="border-top my-3"></div>

                        <!-- Carousel -->
                        <div class="row mb-4">
                            <div class="col-12 col-md-4">
                                <h6 class="fw-bold mb-2 border-start ps-2 text-primary">Carousel</h6>
                            </div>
                            <div v-if="carousel > 1" class="col-12 col-md-8">
                                <div id="carouselExample" class="carousel slide d-flex justify-content-center">
                                    <div class="carousel-inner">
                                        <div class="carousel-item" v-for="(item, index) in carousel" :key="item.id"
                                            :class="{ active: index === 0 }">

                                            <img :src="`/storage/${item.image}`" :alt="`Imagem ${index + 1}`"
                                                class="d-block rounded shadow-sm"
                                                style="width: 220px; height: 220px; object-fit: cover;">
                                        </div>
                                    </div>

                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExample" data-bs-slide="prev">
                                        <span
                                            class="carousel-control-prev-icon bg-primary p-2 rounded-circle small-control"></span>
                                        <span class="visually-hidden">Anterior</span>
                                    </button>

                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExample" data-bs-slide="next">
                                        <span
                                            class="carousel-control-next-icon bg-primary p-2 rounded-circle small-control"></span>
                                        <span class="visually-hidden">Próximo</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="border-top my-3"></div>

                        <!-- Logo -->
                        <div class="row mb-4">
                            <div class="col-12 col-md-4">
                                <h6 class="fw-bold mb-2 border-start ps-2 text-primary">Logo</h6>
                            </div>
                            <div class="col-12 col-md-8" v-if="logo && logo.image">
                                <img class="d-block rounded shadow-sm" :src="`/storage/${logo.image}`" width="400"
                                    height="200" style="object-fit: contain;">
                            </div>
                        </div>

                        <div class="border-top my-3"></div>

                        <!-- Redes sociais -->
                        <div class="row mb-2">
                            <div class="col-12 col-md-4">
                                <h6 class="fw-bold mb-2 border-start ps-2 text-primary">Redes Sociais</h6>
                            </div>
                            <div class="col-12 col-md-8">
                                <ul class="list-unstyled mb-0">
                                    <li v-for="item in socialMedia" :key="item.id"
                                        class="mb-2 d-flex align-items-center">
                                        <i :class="item.icon + ' fs-5 me-2 text-primary'"></i>
                                        <a :href="item.url" target="_blank" class="text-decoration-none fw-semibold">
                                            {{ item.name }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div>
        </div>
    </div>
</template>



<script>
import axios from 'axios';

export default {
    props: {
        urlCreate: String,
        urlEdit: String,
    },
    data() {
        return {
            loading: false,
            main: {},
            about: {},
            carousel: {},
            contact: {},
            logo: {},
            socialMedia: {},
        }
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {
            this.loading = true;
            axios.get('/admin/site/list')
                .then(response => {
                    this.main = response.data.items.main;
                    this.about = response.data.items.about;
                    this.carousel = response.data.items.carousel;
                    this.contact = response.data.items.contatct;
                    this.logo = response.data.items.logo;
                    this.socialMedia = response.data.items.socialMedia;
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
<style>
.small-control {
    width: 24px !important;
    height: 24px !important;
    background-size: 60% 60%;
}
</style>