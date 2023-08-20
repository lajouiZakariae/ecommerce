export function FormGroup({ children, label }) {
    return (
        <div className="flex items-center mb-3">
            <div className="text-lg basis-2/12">{label}</div>
            <div className="basis-10/12">{children}</div>
        </div>
    );
}
export default function Input(props) {
    return (
        <input
            className={`block w-full rounded-md border-0 py-1.5 pl-4 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-800 sm:text-sm sm:leading-6${
                props.className ? props.className : ""
            }`}
            {...props}
        />
    );
}
