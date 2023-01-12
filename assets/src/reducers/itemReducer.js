import {
  SET_ITEMS,
  ADD_ITEM,
  UPDATE_ITEM,
  DELETE_ITEM,
} from "../actions/itemActions";

const initialState = {
  items: [],
};

export default function itemReducer(state = initialState, action) {
  switch (action.type) {
    case SET_ITEMS:
      return {
        ...state,
        items: action.items,
      };
    case ADD_ITEM:
      return {
        ...state,
        items: [action.item, ...state.items],
      };
    case UPDATE_ITEM:
      return {
        ...state,
        items: state.items.map((item) => {
          if (item.id === action.item.id) {
            return {
              ...item,
              ...action.item,
            };
          }
          return item;
        }),
      };
    case DELETE_ITEM:
      return {
        ...state,
        items: state.items.filter((item) => item.id !== action.itemId),
      };
    default:
      return state;
  }
}
