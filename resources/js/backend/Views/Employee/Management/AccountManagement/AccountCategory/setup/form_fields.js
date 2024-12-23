export default [
	{
		name: "title",
		label: "Enter your title",
		type: "text",
		value: "",
	},

	{
		name: "type",
		label: "Enter your type",
		type: "select",
		label: "Select type",
		multiple: false,
		data_list: [
			{
				label: "Income",
				value: "income",
			},
			{
				label: "Expense",
				value: "expense",
			},
		],
		value: "",
	},

	{
		name: "parent_id",
		label: "Enter your parent id",
		type: "number",
		value: "",
	},
];
