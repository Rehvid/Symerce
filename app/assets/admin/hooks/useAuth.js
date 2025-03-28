import {useContext} from "react";
import {AuthContext} from "@/admin/context/AuthContext";

export const useAuth = () => useContext(AuthContext);
