import Image from "next/image";
import React from "react";
import notfound from "@/public/not-found.png";

const Notfound = () => {
  return (
    <div className="max-h-screen ">
      <Image
        src={notfound}
        alt="not found"
        width={1000}
        height={1000}
        className="object-cover h-full w-full"
      />
    </div>
  );
};

export default Notfound;
