import app_config from "../../../../../../Config/app_config";
import setup_type from "./setup_type";

const prefix: string = "AccountExpense";

const setup: setup_type = {
    prefix,
    permission: ["admin", "super_admin"],

    api_host: app_config.api_host,
    api_version: app_config.api_version,
    api_end_point: "account-expenses",

    module_name: "account-expense",
    store_prefix: "account_expense",
    route_prefix: "AccountExpense",
    route_path: "account-expense",

    select_fields: [
        "id",
        "account_category_id",
        "title",
        "amount",
        "description",
        "is_approved",
        "user_type",
        "status",
        "slug",
        "created_at",
        "deleted_at",
    ],

    sort_by_cols: [
        "id",
        "account_category_id",
        "title",
        "amount",
        "description",
        "is_approved",
        "user_type",
        "status",
        "created_at",
    ],
    table_header_data: [
        "id",
        "account_category_id",
        "title",
        "amount",
        "description",
        "is_approved",
        "user_type",
        "status",
        "created_at",
    ],
    table_row_data: [
        "id",
        "account_category_id",
        "title",
        "amount",
        "description",
        "is_approved",
        "user_type",
        "status",
        "created_at",
    ],

    layout_title: prefix + " Management",
    page_title: `${prefix} Management`,

    all_page_title: "All " + prefix,
    details_page_title: "Details " + prefix,
    create_page_title: "Create " + prefix,
    edit_page_title: "Edit " + prefix,
};

export default setup;
