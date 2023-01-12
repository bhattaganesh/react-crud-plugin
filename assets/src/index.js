import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import { Provider } from "react-redux";
import store from "./store";

window.onload = () => {
  const loading = document.querySelector(".loading");
  const root = document.getElementById("react-crud-plugin-admin-root");

  // Hide the loading message.
  loading.style.display = "none";

  // Show the React app.
  if (root) {
    root.style.display = "block";
    ReactDOM.createRoot(root).render(
      <Provider store={store}>
          <App />
      </Provider>
    );
  }
};
