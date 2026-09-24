"use client";

import React, { useEffect, useState } from 'react';
import { BiChevronRight, BiPlus } from 'react-icons/bi';
// import { AnimatePresence, motion } from 'motion/react';
import { FaPlus } from 'react-icons/fa6';

const Contacts = ({ openNewTab }) => {
    const [contacts, setContacts] = useState([]);

    useEffect(() => {
        let c = localStorage.getItem('contacts');

        if (c) {
            setContacts(JSON.parse(c));
        }
    }, []);

    return (
        <div className="w-full flex-1 h-full bg-s-200 overflow-y-auto">
            <div className="w-full h-14 px-3 sticky top-0 bg-gray-700 grid items-center">
                <input type="text" placeholder="Search for a contact" className="bg-gray-300 dark:bg-gray-800 px-3 py-2 rounded-full w-full text-sm focus:outline-none" />
            </div>

            {contacts.map((i) =>
                <div key={i} className="w-full h-16 flex items-center mb-2">
                    <div className="size-12 rounded-full bg-gray-400 dark:bg-gray-800 grid place-items-center text-2xl text-white mx-3">
                        {i.name.charAt(0)}
                    </div>

                    <div className="text-lg">{i.name}</div>

                    <BiChevronRight className="size-6 text-transparent cursor-pointer" />
                </div>
            )}

            <div className='absolute bottom-1.5 z-10 right-3 grid place-items-center h-12 w-12 bg-cyan-600 rounded-full' onClick={openNewTab}>
                <FaPlus className='size-7' />
            </div>
        </div>
    )
}

export default Contacts;