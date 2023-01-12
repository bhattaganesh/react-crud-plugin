import "./ItemForm.css";
import React from "react";
import { useSelector, useDispatch } from "react-redux";
import { addItem, updateItem } from "../actions/itemActions";
import { handleChange, closeModal } from "../actions/modalActions";
import { setError, setSuccess } from "../actions/noticeActions";
import axios from "axios";

const ItemForm = () => {
  const restUrl = reactCrudPluginData.restUrl;
  const nonce = reactCrudPluginData.nonce;

  const dispatch = useDispatch();
  const { itemId, itemTitle, itemDescription } = useSelector(
    (state) => state.modalOpen
  );

  const handleChangeHandler = (e) => {
    dispatch(handleChange(e));
  };

  const closeModalHandler = () => {
    dispatch(closeModal());
  };

  const addItemHandler = (e) => {
    e.preventDefault();
    axios
      .post(
        `${restUrl}/items`,
        {
          title: itemTitle,
          description: itemDescription,
        },
        {
          headers: {
            "Content-Type": "application/json",
            "X-WP-Nonce": nonce,
          },
        }
      )
      .then((res) => {
        if (res.data.success) {
          const newItem = {
            id: res.data.data.id,
            title: itemTitle,
            description: itemDescription,
          };
          dispatch(addItem(newItem));
          closeModalHandler();
          dispatch(setSuccess(res.data.data.message));
        } else {
          dispatch(setError(res.data.data.message));
        }
      })
      .catch((err) => {
        dispatch(setError(err.response.data.message));
      });
  };

  const updateItemHandler = (e) => {
    e.preventDefault();
    axios
      .put(
        `${restUrl}/item/${itemId}`,
        {
          title: itemTitle,
          description: itemDescription,
        },
        {
          headers: {
            "Content-Type": "application/json",
            "X-WP-Nonce": nonce,
          },
        }
      )
      .then((res) => {
        if (res.data.success) {
          const updatedItem = {
            id: itemId,
            title: itemTitle,
            description: itemDescription,
          };
          dispatch(updateItem(updatedItem));
          closeModalHandler();
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
    <form onSubmit={itemId ? updateItemHandler : addItemHandler}>
      <input type="hidden" name="itemId" value={itemId} />
      <table className="form-table">
        <tbody>
          <tr>
            <th scope="row">
              <label htmlFor="itemTitle">Title</label>
            </th>
            <td>
              <input
                type="text"
                name="itemTitle"
                id="itemTitle"
                defaultValue={itemTitle}
                onChange={handleChangeHandler}
                required
              />
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label htmlFor="itemDescription">Description</label>
            </th>
            <td>
              <textarea
                name="itemDescription"
                id="itemDescription"
                rows={2}
                defaultValue={itemDescription}
                onChange={handleChangeHandler}
              />
            </td>
          </tr>
        </tbody>
      </table>
      <p className="submit">
        <button type="submit" className="button button-primary">
          {itemId ? "Update Item" : "Add Item"}
        </button>
      </p>
    </form>
  );
};

export default ItemForm;
