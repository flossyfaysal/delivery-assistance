import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import edit from "./edit";
import save from "./save";

registerBlockType("delivery-assistance/login", {
  title: __("Delivery Assistance - Login", "delivery-assistance"),
  description: __("A simple block for demonstration.", "delivery-assistance"),
  icon: "smiley",
  category: "widgets",
  edit,
  save,
});
