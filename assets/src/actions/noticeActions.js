export const SET_SUCCESS = "SET_SUCCESS";
export const SET_ERROR = "SET_ERROR";
export const DISMISS_NOTICE = "DISMISS_NOTICE";

export const setSuccess = (success) => {
  return {
    type: SET_SUCCESS,
    success,
  };
};

export const setError = (error) => {
  return {
    type: SET_ERROR,
    error,
  };
};

export const dismissNotice = () => {
  return {
    type: DISMISS_NOTICE,
  };
};
