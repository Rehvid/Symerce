const Forbidden = () => {
    return (
        <div className="flex flex-col min-h-screen justify-center items-center gap-6">
            <h1 className="text-7xl font-medium uppercase mb-4">403 - Brak dostępu</h1>
            <p className="text-3xl text-gray-700">Nie masz wystarczających uprawnień do przeglądania tej strony.</p>
        </div>
    );
};

export default Forbidden;
