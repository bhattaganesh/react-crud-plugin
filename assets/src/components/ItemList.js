import "./ItemList.css";
import React, { useEffect } from "react";
import { useSelector, useDispatch } from "react-redux";
import { setLoading } from "../actions/loadingActions";
import { setItems, deleteItem } from "../actions/itemActions";
import { setError, setSuccess } from "../actions/noticeActions";
import axios from "axios";

const ItemList = ({ onOpenModal }) => {
  const restUrl = reactCrudPluginData.restUrl;
  const nonce = reactCrudPluginData.nonce;

  const dispatch = useDispatch();
  const { loading, items } = useSelector((state) => state);

  useEffect(() => {
    axios
      .get(restUrl + "/items", {
        headers: {
          "Content-Type": "application/json",
        },
      })
      .then((res) => {
        if (res.data.success) {
          dispatch(setItems(res.data.data));
          dispatch(setLoading(false));
        }
      })
      .catch((err) => {
        dispatch(setError(err.response.data.message));
        dispatch(setLoading(false));
      });
  }, []);

  const deleteItemHandler = (id) => {
    axios
      .delete(`${restUrl}/item/${id}`, {
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": nonce,
        },
      })
      .then((res) => {
        if (res.data.success) {
          dispatch(deleteItem(id));
          dispatch(setSuccess(res.data.data.message));
        } else {
          dispatch(setError(res.data.data.message));
        }
      })
      .catch((err) => {
        dispatch(setError(err.response.data.message));
      });
  };

  return (
    <>
      {loading.loading ? (
        <p>Loading...</p>
      ) : (
        <>
          <table className="wp-list-table widefat fixed striped items">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {items.items.length > 0 ? (
                items.items.map((item) => (
                  <tr key={item.id}>
                    <td>{item.id}</td>
                    <td>{item.title}</td>
                    <td>{item.description}</td>
                    <td>
                      <button
                        className="button button-link"
                        onClick={() => onOpenModal(item)}
                      >
                        Edit
                      </button>
                      <button
                        className="button button-link"
                        onClick={() => deleteItemHandler(item.id)}
                      >
                        Delete
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="4">No items found</td>
                </tr>
              )}
            </tbody>
          </table>
        </>
      )}
    </>
  );
};

export default ItemList;
