<template>
    <!--Start sidebar-wrapper-->
    <div id="sidebar-wrapper">
        <div class="brand-logo">
            <router-link
                :to="{ name: `adminDashboard` }"
                class="d-flex align-items-center"
            >
                <img
                    :src="`${get_setting_value('image') ?? 'avatar.png'} `"
                    class="logo-icon"
                    alt="logo icon"
                />
                <h5 class="logo-text">Employee Panel</h5>
            </router-link>
            <div class="close-btn">
                <i class="zmdi zmdi-close" @click="toggle_menu"></i>
            </div>
        </div>

        <div class="text-center mt-3">
            <img
                class="rounded-circle p-1"
                height="70"
                width="70"
                :src="`${auth_info.image ?? 'avatar.png'}`"
                alt=""
            />
            <p class="mt-2">Mr. {{ auth_info.name }}</p>
        </div>
        <hr />
        <ul class="metismenu" id="menu">
            <!-- <li class="menu-label">Management</li> -->
            <li>
                <router-link
                    :to="{ name: `adminDashboard` }"
                    class="border"
                    href="javascript:void();"
                >
                    <div class="parent-icon">
                        <i class="zmdi zmdi-view-dashboard"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </router-link>
            </li>
            <!-- Management start -->


            <side-bar-drop-down-menus
                :icon="`fa fa-plus`"
                :icon_image="`https://files.etek.com.bd/images/icon_sales.png`"
                :menu_title="`Product Management`"
                :menus="[
                    {
                        route_name: `AllProductCategory`,
                        title: `Product Category`,
                        icon: `zmdi zmdi-dot-circle-alt`,
                    },
                    {
                        route_name: `AllProductSubCategory`,
                        title: `Product SubCategory`,
                        icon: `zmdi zmdi-dot-circle-alt`,
                    },
                    {
                        route_name: `AllProduct`,
                        title: `Product`,
                        icon: `zmdi zmdi-dot-circle-alt`,
                    },
                ]"
            />


            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`Suppliyer`"
                :route_name="`AllSuppliyer`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`PurchaseOrder`"
                :route_name="`AllPurchaseOrder`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`WareHouse`"
                :route_name="`AllWareHouse`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`WareHouseProductStock`"
                :route_name="`AllWareHouseProductStock`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`WarehouseProductOut`"
                :route_name="`AllWarehouseProductOut`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`SalesOrder`"
                :route_name="`AllSalesOrder`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`SalesOrderCollectionHistory`"
                :route_name="`AllSalesOrderCollectionHistory`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`AccountCategory`"
                :route_name="`AllAccountCategory`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`AccountSubCategory`"
                :route_name="`AllAccountSubCategory`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`AccountIncome`"
                :route_name="`AllAccountIncome`"
            />
            <side-bar-single-menu
                :icon="`fa fa-plus`"
                :menu_title="`AccountExpense`"
                :route_name="`AllAccountExpense`"
            />
            <!-- Management end -->
        </ul>
    </div>
</template>

<script>
//auth_store
import { auth_store } from "../../../../../GlobalStore/auth_store";
import { site_settings_store } from "../../../../../GlobalStore/site_settings_store";
import { mapState, mapActions } from "pinia";
//components
import SideBarDropDownMenus from "./SideBarDropDownMenus.vue";
import SideBarSingleMenu from "./SideBarSingleMenu.vue";
export default {
    components: { SideBarDropDownMenus, SideBarSingleMenu },
    methods: {
        ...mapActions(site_settings_store, {
            get_setting_value: "get_setting_value",
        }),

        logout_submit: function () {
            let confirm = window.confirm("logout");
            if (confirm) {
                this.log_out();
            }
        },
        toggle_menu: function () {
            document.getElementById("wrapper").classList.toggle("toggled");
        },
    },
    computed: {
        ...mapState(auth_store, {
            auth_info: "auth_info",
        }),
    },
};
</script>

<style></style>
<!-- <side-bar-drop-down-menus :icon="`fa fa-plus`" :icon_image="`https://files.etek.com.bd/images/icon_sales.png`"
    :menu_title="`title Management`" :menus="[
                {
                    route_name: `AllUser`,
                    title: `title`,
                    icon: `zmdi zmdi-dot-circle-alt`,
                },
            ]" /> -->
