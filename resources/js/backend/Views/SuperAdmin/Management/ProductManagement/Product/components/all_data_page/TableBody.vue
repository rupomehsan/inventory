<template>
  <tr
    v-for="(item, dataindex) in data"
    :key="item.id"
    :class="`table_rows table_row_${item.id}`"
  >
    <td>
      <table-row-action :item="item"></table-row-action>
    </td>
    <td>
      <select-single :data="item" />
    </td>
    <template v-for="(row_item, index) in setup.table_row_data" :key="index">
      <td v-if="row_item == 'id'">{{ dataindex + 1 }}</td>
      <td v-else class="text-wrap max-w-120">
        <template v-if="row_item == 'image' && item[row_item]">
          <img width="70" :src="item[row_item]" alt="" />
        </template>
        <template v-else>
          {{ trim_content(item[row_item], row_item) }}
        </template>
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
    trim_content(content, row_item = null) {
      if (typeof content == "string") {
        if (row_item == "created_at" || row_item == "updated_at") {
          return new Date(content).toLocaleTimeString();
        }

        return content.length > 20 ? content.substring(0, 20) + "..." : content;
      }
      if (content && typeof content === "object") {
        for (const key of Object.keys(content)) {
          if (key === "title" && content.title) {
            return content.title.length > 50
              ? content.title.substring(0, 50) + "..."
              : content.title;
          }
          if (key === "name" && content.name) {
            return content.name.substring(0, 20) + "...";
          }
        }
      }
      return content;
    },
  },
};
</script>

<style scoped>
.max-w-120 {
  max-width: 120px;
}
</style>
