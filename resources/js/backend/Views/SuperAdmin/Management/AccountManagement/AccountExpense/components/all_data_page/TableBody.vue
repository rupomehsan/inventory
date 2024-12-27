<template>
    <tr
        v-for="item in data"
        :key="item.id"
        :class="`table_rows table_row_${item.id}`"
    >
        <td>
            <table-row-action :item="item"></table-row-action>
        </td>
        <td>
            <select-single :data="item" />
        </td>
        <template
            v-for="(row_item, index) in setup.table_row_data"
            :key="index"
        >
            <td class="text-wrap max-w-120">
                {{ trim_content(item[row_item]) }}
            </td>
        </template>
    </tr>
</template>

<script>
import setup from "../../setup";
import SelectAll from "./select_data/SelectAll.vue";
import TableRowAction from "./TableRowAction.vue";
import SelectSingle from "./select_data/SelectSingle.vue";
export default {
    props: ["data"],
    data: () => ({
        setup,
    }),
    components: {
        SelectAll,
        TableRowAction,
        SelectSingle,
    },

    methods: {
        trim_content(content) {
            if (typeof content == "string") {
                return content.length > 50
                    ? content.substring(0, 50) + "..."
                    : content;
            }
            if (content && typeof content === "object") {
                for (const key of Object.keys(content)) {
                    if (key === "title" && content.title) {
                        return content.title;
                    }
                    if (key === "name" && content.name) {
                        return content.name;
                    }
                }
            }

            return content || "";
        },
    },
};
</script>

<style scoped>
.max-w-120 {
    max-width: 120px;
}
</style>
