<template>
    <div class="sidebar">
        <div class="logo">
            <a :href="urlHome" class="logo-link">
                <img v-show="logo" :src="'/storage/' + logo" alt="Logo" class="logo-img">
            </a>
        </div>
        <ul class="sidebar-list">
            <li v-for="menu in orderedMenus" :key="menu.id">
                <template v-if="menu.children && menu.children.length > 0">
                    <div>
                        <a href="#" class="sidebar-nav" @click.prevent="toggleSubmenu(menu)">
                            <i id="icon" :class="menu.icon"></i>
                            <span style="margin-left: 10px;">{{ menu.label }}</span>
                            <i class="bi bi-caret-down" :class="{ 'open': menu.expanded }"></i>
                        </a>
                        <ul class="sidebar-submenu-list" v-show="menu.expanded">
                            <li v-for="child in menu.children" :key="child.id">
                                <a class="sidebar-nav" :href="child.url">
                                    <i id="icon" :class="child.icon"></i>
                                    <span style="margin-left: 10px;">{{ child.label }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </template>
                <template v-else>
                    <a class="sidebar-nav" :href="menu.url">
                        <i id="icon" :class="menu.icon"></i>
                        <span style="margin-left: 10px;">{{ menu.label }}</span>
                    </a>
                </template>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'Sidebar',
    props: {
        urlHome: String,
        logo: String,
    },
    data() {
        return {
            menus: [],
        };
    },
    computed: {
        orderedMenus() {
            const homeMenu = this.menus.find(menu => menu.label === 'Home');
            const adminMenu = this.menus.find(menu => menu.label === 'Administrativo');
            const logoutMenu = this.menus.find(menu => menu.label === 'Sair');
            const otherMenus = this.menus.filter(menu => menu.label !== 'Home' && menu.label !== 'Administrativo' && menu.label !== 'Sair');

            return [
                ...(homeMenu ? [homeMenu] : []),
                ...(adminMenu ? [adminMenu] : []),
                ...otherMenus,
                ...(logoutMenu ? [logoutMenu] : []),
            ];
        }
    },
    created() {
        this.getMenus();
    },
    methods: {
        getMenus() {
            axios.get('/admin/menus')
                .then(response => {
                    this.menus = response.data.map(menu => ({
                        ...menu,
                        expanded: false,
                    }));
                })
                .catch(error => {
                    console.error(error);
                });
        },
        toggleSubmenu(menu) {
            menu.expanded = !menu.expanded;
        },
    }
};
</script>
