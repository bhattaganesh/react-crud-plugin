import "./ItemModal.css";
import React from "react";
import ItemForm from "./ItemForm";
import { useDispatch } from "react-redux";
import { closeModal } from "../actions/modalActions";
const ItemModal = () => {
  const dispatch = useDispatch();
  const closeModalHandler = () => {
    dispatch(closeModal());
  };
  return (
    <div className="modal-wrap">
      <div className="modal-container">
        <button className="modal-close button" onClick={closeModalHandler}>
          Close
        </button>
        <ItemForm />
      </div>
    </div>
  );
};

export default ItemModal;
