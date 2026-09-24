"use client";

import React, { useState } from "react";

const NewContact = ({ onSave }) => {
    const [name, setName] = useState("");
    const [phone, setPhone] = useState("");
    const [email, setEmail] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!name || !phone) return;
        onSave && onSave({ name, phone, email });
        setName("");
        setPhone("");
        setEmail("");
    };

    return (
        <div className="w-full h-full bg-black rounded-sm text-base overflow-auto">
            <form onSubmit={handleSubmit} className="w-full h-fit bg-black p-4 rounded-sm text-base overflow-auto">
                <h2 className="text-white text-3xl font-semibold mt-2 mb-6">New Contact</h2>

                <div className="mb-3">
                    <input
                        type="text"
                        value={name}
                        onChange={e => setName(e.target.value)}
                        className="w-full p-2 px-3 borde2 dark:border-white rounded-xl bg-gray-900"
                        placeholder="Full Name"
                        required
                    />
                </div>

                <div className="mb-3">
                    <input
                        type="tel"
                        value={phone}
                        onChange={e => setPhone(e.target.value)}
                        className="w-full p-2 px-3 borde2 dark:border-white rounded-xl bg-gray-900"
                        placeholder="Phone Number"
                        required
                    />
                </div>

                <div className="mb-3">
                    <input
                        type="email"
                        value={email}
                        onChange={e => setEmail(e.target.value)}
                        className="w-full p-2 px-3 borde2 dark:border-white rounded-xl bg-gray-900"
                        placeholder="Email (optional)"
                    />
                </div>

                <button type="submit" className="p-1 px-4 bg-blue-500 text-white rounded text-lg cursor-pointer mx-auto block mt-6">Save</button>
            </form>
        </div>
    );
};

export default NewContact;