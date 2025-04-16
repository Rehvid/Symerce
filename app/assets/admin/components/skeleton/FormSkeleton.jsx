const FormSkeleton = ({rowsCount }) => {
  return (
    <div className="animate-pulse space-y-6">

      <div className="h-6 bg-gray-200 w-full rounded"></div>
      <div className="h-6 bg-gray-200 w-full rounded"></div>
      <div className="h-6 bg-gray-200 w-full rounded"></div>
      <div className="h-6 bg-gray-200 w-full rounded"></div>
      <div className="h-6 bg-gray-200 w-full rounded"></div>
      <div className="h-6 bg-gray-200 w-full rounded"></div>
      <div className="h-6 bg-gray-200 w-full rounded"></div>

      {Array.from({ length: rowsCount }, (_, i) => (
        <div key={i} className="h-4 bg-gray-200 rounded"></div>
      ))}
    </div>
  );
}

export default FormSkeleton;
