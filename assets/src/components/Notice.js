import "./Notice.css";
import React from "react";
import { useDispatch } from "react-redux";
import { dismissNotice } from "../actions/noticeActions";
const Notice = ({ message, type }) => {
  const dispatch = useDispatch();
  const dismissNoticeHandler = () => {
    dispatch(dismissNotice());
  };
  return (
    <div className={`notice notice-${type}`}>
      <p>{message}</p>
      <button
        type="button"
        className="notice-dismiss"
        onClick={dismissNoticeHandler}
      ></button>
    </div>
  );
};

export default Notice;
