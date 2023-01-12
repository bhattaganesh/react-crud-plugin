export const OPEN_MODAL = "OPEN_MODAL";
export const CLOSE_MODAL = "CLOSE_MODAL";
export const SET_ITEM_TITLE = "SET_ITEM_TITLE";
export const SET_ITEM_DESCRIPTION = "SET_ITEM_DESCRIPTION";

export const openModal = (item) => ({
  type: OPEN_MODAL,
  modalOpen: true,
  itemId: item ? item.id : null,
  itemTitle: item ? item.title : "",
  itemDescription: item ? item.description : "",
});

export const closeModal = () => ({
  type: CLOSE_MODAL,
  modalOpen: false,
  itemId: null,
  itemTitle: "",
  itemDescription: "",
});

export const setItemId = (itemId) => {
  return {
    type: SET_ITEM_ID,
    itemId,
  };
};

export const setItemDescription = (itemDescription) => {
  return {
    type: SET_ITEM_DESCRIPTION,
    itemDescription,
  };
};

export const handleChange = (e) => {
  if (e.target.name === "itemTitle") {
    return {
      type: SET_ITEM_TITLE,
      itemTitle: e.target.value,
    };
  } else if (e.target.name === "itemDescription") {
    return {
      type: SET_ITEM_DESCRIPTION,
      itemDescription: e.target.value,
    };
  }
};
