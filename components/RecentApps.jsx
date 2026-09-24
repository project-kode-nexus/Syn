"use client";

import React from 'react';

const RecentApps = () => {
    return (
        <div>
            {openedApps.map(app => (
                <div key={app.id}>
                    <img src={app.icon} alt={app.name} />
                    <span>{app.name}</span>
                </div>
            ))}
        </div>
    );
};

export default RecentApps;