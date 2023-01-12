import "./App.css";
import React from "react";
import { useSelector, useDispatch } from "react-redux";
import { openModal } from "./actions/modalActions";

import ItemList from "./components/ItemList";
import ItemModal from "./components/ItemModal";
import Notice from "./components/Notice";

const App = () => {
  const modalOpen = useSelector((state) => state.modalOpen.modalOpen);
  const error = useSelector((state) => state.error.error);
  const success = useSelector((state) => state.success.success);
  const dispatch = useDispatch();

  const openModalHandler = (item) => {
    dispatch(openModal(item));
  };
  return (
    <div className="wrap">
      <h1>React CRUD Plugin</h1>
      {success && <Notice type={"success"} message={success} />}
      {error && <Notice type={"error"} message={error} />}
      <button className="button button-primary add" onClick={openModalHandler}>
        Add Item
      </button>
      <ItemList onOpenModal={openModalHandler} />
      {modalOpen && <ItemModal />}
    </div>
  );
};

export default App;
