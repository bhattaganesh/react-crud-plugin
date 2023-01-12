import { combineReducers } from "redux";
import itemReducer from "./itemReducer";
import loadingReducer from "./loadingReducer";
import modalReducer from "./modalReducer";
import noticeReducer from "./noticeReducer";

const rootReducer = combineReducers({
  items: itemReducer,
  loading: loadingReducer,
  modalOpen: modalReducer,
  error: noticeReducer,
  success: noticeReducer,
});

export default rootReducer;
