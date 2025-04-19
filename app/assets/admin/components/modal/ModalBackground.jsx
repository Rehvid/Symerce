const ModalBackground = ({ children }) => {
    return (
        <div className="relative w-full max-w-5xl flex items-center justify-center mx-auto h-full">
            <div className="relative bg-white rounded-lg shadow-2xl  min-w-[250px] max-h-3/4 overflow-auto ">
                {children}
            </div>
        </div>
    );
};

export default ModalBackground;
