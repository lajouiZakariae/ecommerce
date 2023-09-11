import { useAtom, useAtomValue } from "jotai";
import actionsStack from "../atoms/actionsStack";

export default function Controls() {
    const [actions, dispatch] = useAtom(actionsStack);

    return (
        <div className="mt-2">
            <button
                className="py-1 px-2 border cursor-pointer hover:bg-gray-100 disabled:opacity-70 disabled:bg-white "
                disabled={!actions.undos.length}
                onClick={() => dispatch({ type: "UNDO" })}
            >
                UNDO
            </button>
            <button
                className="py-1 px-2 border cursor-pointer hover:bg-gray-100 disabled:opacity-70 disabled:bg-white "
                disabled={!actions.redos.length}
                onClick={() => dispatch({ type: "REDO" })}
            >
                REDO
            </button>
        </div>
    );
}
