import { SET_LOADING } from "../actions/loadingActions";

const initialState = {
  loading: true,
};

export default function loadingReducer(state = initialState, action) {
  switch (action.type) {
    case SET_LOADING:
      return {
        ...state,
        loading: action.loading,
      };
    default:
      return state;
  }
}
