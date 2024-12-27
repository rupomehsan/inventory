<template>
    <div>
        <form @submit.prevent="submitHandler">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-capitalize">
                        {{
                            param_id
                                ? `${setup.edit_page_title}`
                                : `${setup.create_page_title}`
                        }}
                    </h5>
                    <div>
                        <router-link
                            v-if="item.slug"
                            class="btn btn-outline-info mr-2 btn-sm"
                            :to="{
                                name: `Details${setup.route_prefix}`,
                                params: { id: item.slug },
                            }"
                        >
                            {{ setup.details_page_title }}
                        </router-link>
                        <router-link
                            class="btn btn-outline-warning btn-sm"
                            :to="{ name: `All${setup.route_prefix}` }"
                        >
                            {{ setup.all_page_title }}
                        </router-link>
                    </div>
                </div>
                <div class="card-body card_body_fixed_height">
                    <div class="row">
                        <template
                            v-for="(form_field, index) in form_fields"
                            v-bind:key="index"
                        >
                            <common-input
                                :label="form_field.label"
                                :type="form_field.type"
                                :name="form_field.name"
                                :multiple="form_field.multiple"
                                :value="form_field.value"
                                :data_list="form_field.data_list"
                                :is_visible="form_field.is_visible"
                                :row_col_class="form_field.row_col_class"
                                :onchange="changeAction"
                                :onchangeAction="form_field.onchangeAction"
                            />
                        </template>
                    </div>
                    <div class="row justify-content-center">

                        <div class="col-lg-5 card">
                            <div class="card-header">
                                <h5>Order Details</h5>
                            </div>
                            <div class="crad-body">
                                <table>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                    <tr
                                        v-for="product in item.sales_order_products"
                                        :key="product.id"
                                    >
                                        <td>{{ product.product_name }}</td>
                                        <td>{{ product.quantity }}</td>
                                        <td>{{ product.price }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-5 card">
                            <div class="card-header">
                                <h5>Order Collection History</h5>
                            </div>
                            <div class="crad-body py-2">
                                <table class="table table-bordered table-hover table-striped ">
                                    <tr>
                                        <th>Date </th>
                                        <th>Amount</th>
                                    </tr>
                                    <tr
                                        v-for="i in 5"
                                        :key="i"
                                    >
                                        <td>sadfas</td>
                                        <td>500</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-light btn-square px-5">
                        <i class="icon-lock"></i>
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { store } from "../store";
import setup from "../setup";
import form_fields from "../setup/form_fields";

export default {
    data: () => ({
        setup,
        form_fields,
        param_id: null,
    }),
    created: async function () {
        let id = (this.param_id = this.$route.params.id);
        this.reset_fields();
        if (id) {
            this.set_fields(id);
        }

        await this.get_all_sales_orders();
    },
    methods: {
        ...mapActions(store, {
            create: "create",
            update: "update",
            details: "details",
            get_all: "get_all",
            set_only_latest_data: "set_only_latest_data",
        }),
        reset_fields: function () {
            this.form_fields.forEach((item) => {
                item.value = "";
            });
        },
        set_fields: async function (id) {
            this.param_id = id;
            await this.details(id);
            if (this.item) {
                this.form_fields.forEach((field, index) => {
                    Object.entries(this.item).forEach((value) => {
                        if (field.name == value[0]) {
                            this.form_fields[index].value = value[1];
                        }
                    });
                });
            }
        },

        submitHandler: async function ($event) {
            this.set_only_latest_data(true);
            if (this.param_id) {
                let response = await this.update($event);
                // await this.get_all();
                if ([200, 201].includes(response.status)) {
                    window.s_alert("Data successfully updated");
                    this.$router.push({
                        name: `Details${this.setup.route_prefix}`,
                    });
                }
            } else {
                let response = await this.create($event);
                // await this.get_all();
                if ([200, 201].includes(response.status)) {
                    window.s_alert("Data Successfully Created");
                    this.$router.push({
                        name: `All${this.setup.route_prefix}`,
                    });
                }
            }
        },

        get_all_sales_orders: async function () {
            let response = await axios.get("sales-orders?get_all=1");
            if (response.data.status == "success") {
                response = response.data.data;
                this.form_fields[0].data_list = [];
                response.forEach((item) => {
                    let dataList = {};
                    dataList.label = item.title + " - " + item.reference;
                    dataList.value = item.id;
                    this.form_fields[0].data_list.push(dataList);
                });
            }
        },

        changeAction: function (actionTitle, event, ref) {
            this[actionTitle](actionTitle, event, ref);
        },
        get_sales_order_collection_history_by_sales_order_id: async function (
            actionTitle,
            event,
            ref
        ) {
            let response = await axios.get(
                "sales-orders/" + event.target.value
            );
        },
    },

    computed: {
        ...mapState(store, {
            item: "item",
        }),
    },
};
</script>
