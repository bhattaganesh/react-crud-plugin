import { SET_SUCCESS, SET_ERROR, DISMISS_NOTICE } from "../actions/noticeActions";

const initialState = {
  success: null,
  error: null,
};

export default function noticeReducer(state = initialState, action) {
  switch (action.type) {
    case SET_SUCCESS:
      return {
        ...state,
        success: action.success,
      };
    case SET_ERROR:
      return {
        ...state,
        error: action.error,
      };
    case DISMISS_NOTICE:
      return {
        ...state,
        success: null,
        error: null,
      };
    default:
      return state;
  }
}
