export const SET_ITEMS = "SET_ITEMS";
export const ADD_ITEM = "ADD_ITEM";
export const UPDATE_ITEM = "UPDATE_ITEM";
export const DELETE_ITEM = "DELETE_ITEM";

// Actions.
export const setItems = (items) => {
  return {
    type: SET_ITEMS,
    items,
  };
};

export const addItem = (item) => ({
  type: ADD_ITEM,
  item,
});

export const updateItem = (item) => ({
  type: UPDATE_ITEM,
  item,
});

export const deleteItem = (itemId) => {
  return {
    type: DELETE_ITEM,
    itemId,
  };
};
