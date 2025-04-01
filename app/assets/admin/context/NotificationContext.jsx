import {createContext, useState} from "react";
import AppNotification from "@/admin/components/Common/AppNotification";

export const NotificationContext = createContext({});

export const NotificationProvider = ({ children }) => {
    const [notifications, setNotifications] = useState([]);
    const TIMEOUT_DELAY = 3000;

    const addNotification = (label, variant) => {
        setNotifications((prev) => [...prev, { id: Date.now(), label, variant, time: TIMEOUT_DELAY }]);
        setTimeout(() => {
            setNotifications((prev) => prev.slice(1));
        }, TIMEOUT_DELAY);
    };

    return (
        <NotificationContext.Provider value={{ addNotification }}>
            <div className="absolute top-14 right-26 z-50">
                {notifications.map((notif) => (
                    <AppNotification
                        key={notif.id}
                        label={notif.label}
                        variant={notif.variant}
                        time={notif.time}
                    />
                ))}
            </div>
            {children}
        </NotificationContext.Provider>
    );
};
