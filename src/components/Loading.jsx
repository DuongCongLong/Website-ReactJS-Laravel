import React from "react";
import AppUrl from "../api/AppURL";
export default function Loading() {
    return (
        <div style={{ textalign: "center" }}>
            <img
                src={`${AppUrl.ImageFE}/img/Spin123.gif`}
                alt="Loading..."
            />
        </div>
    );
}
