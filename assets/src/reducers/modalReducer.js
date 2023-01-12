import {
  OPEN_MODAL,
  CLOSE_MODAL,
  SET_ITEM_ID,
  SET_ITEM_TITLE,
  SET_ITEM_DESCRIPTION,
} from "../actions/modalActions";

const initialState = {
  modalOpen: false,
  itemId: null,
  itemTitle: "",
  itemDescription: "",
};

export default function modalReducer(state = initialState, action) {
  switch (action.type) {
    case OPEN_MODAL:
      return {
        ...state,
        modalOpen: true,
        itemId: action.itemId,
        itemTitle: action.itemTitle,
        itemDescription: action.itemDescription,
      };
    case CLOSE_MODAL:
      return {
        ...state,
        modalOpen: false,
        itemId: null,
        itemTitle: "",
        itemDescription: "",
      };
    case SET_ITEM_TITLE:
      return {
        ...state,
        itemTitle: action.itemTitle,
      };
    case SET_ITEM_DESCRIPTION:
      return {
        ...state,
        itemDescription: action.itemDescription,
      };
    default:
      return state;
  }
}
