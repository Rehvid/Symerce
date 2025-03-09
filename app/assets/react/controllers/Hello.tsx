import React from 'react';

export default function Hello (props: any)  {
    return <div className="text-3xl font-bold underline">Hello,  ser {props?.name}!</div>;
}
