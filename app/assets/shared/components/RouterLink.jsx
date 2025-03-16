import React from "react";
import {Link} from "react-router-dom";

function RouterLink ({navigateTo, label, additionalClassNames}) {
    return (
        <Link
            className={`block py-2 font-medium text-blue-600 dark:text-blue-500 hover:underline ${additionalClassNames}`}
            to={navigateTo}
        > {label}
        </Link>
    )
}

export default RouterLink;
