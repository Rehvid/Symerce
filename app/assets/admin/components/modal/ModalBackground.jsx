import React from 'react';

const ModalBackground = ({children}) => {
  return (
    <div className="relative w-full max-w-5xl max-h-full flex items-center justify-center mx-auto h-full">
      <div className="relative bg-white rounded-lg shadow-2xl  min-w-[250px] ">
        {children}
      </div>
    </div>
  )
}

export default ModalBackground;
