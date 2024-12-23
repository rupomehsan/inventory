export default [
	{
		name: "account_category_id",
		label: "Enter your account category id",
		type: "number",
		value: "",
	},

	{
		name: "title",
		label: "Enter your title",
		type: "text",
		value: "",
	},

	{
		name: "amount",
		label: "Enter your amount",
		type: "number",
		value: "",
	},

	{
		name: "description",
		label: "Enter your description",
		type: "text",
		value: "",
	},

	{
		name: "is_approved",
		label: "Enter your is approved",
		type: "radio",
		value: "",
	},

	{
		name: "user_type",
		label: "Enter your user type",
		type: "select",
		label: "Select user type",
		multiple: false,
		data_list: [
			{
				label: "Admin",
				value: "admin",
			},
			{
				label: "Employee",
				value: "employee",
			},
		],
		value: "",
	},
];
