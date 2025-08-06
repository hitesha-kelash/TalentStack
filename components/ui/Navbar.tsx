"use client";
import React, { useEffect, useState } from "react";
import MaxWidthWrapper from "../Shared/maxWidthWrapper";
import { Flower, SidebarClose, SidebarOpen } from "lucide-react";
import Link from "next/link";
import { Button } from "./button";
import { AnimatePresence, motion } from "motion/react";
import { useRouter } from "next/navigation";
import { useSession } from "next-auth/react";
import Image from "next/image";

const NavItems_Not_loggedin = [
  { name: "Features", link: "/feat" },
  { name: "Pricing", link: "/pricing" },
  { name: "About", link: "/about" },
];

const Navbar = () => {
  const { data: session } = useSession();

  const router = useRouter();
  const [open, setOpen] = useState(false);
  const [userdata, setuserdata] = useState(false);
  let profilesrc = "";
  let profilealt = "";

  useEffect(() => {
    if (session?.user) {
      setuserdata(true);
      if (session.user.image) {
        profilesrc = session.user.image;
      }
      if (session.user.email) {
        profilealt = session.user.email;
      }

      console.log(session.user);
    }
  }, [session]);

  const handlonClickSidebar = () => {
    setOpen(!open);
  };
  return (
    <div className="sticky h-20  z-[100] w-full inset-x-0 top-0 backdrop-blur-2xl  border-high/5 border-b ">
      {/* This is Desktop nav */}
      <MaxWidthWrapper className="  flex justify-between align-middle items-center  relative">
        <div className="logo flex justify-center align-middle items-center">
          <Link
            className="flex justify-center align-middle items-center gap-2"
            href={"/"}
          >
            <Flower className="" size={40} color="#b78bf2" />{" "}
            <span className="text-high text-2xl">FreeFlow</span>
          </Link>
        </div>
        <div className=" hidden centeritesm gap-5 sm:flex flex-row">
          {NavItems_Not_loggedin.map((nav, id) => (
            <Link key={id} href={nav.link} className="hover:text-high text-lg">
              {nav.name}
            </Link>
          ))}
        </div>

        {userdata ? (
          <div className="">
            <Image
              src={profilesrc}
              alt={profilealt}
              width={800}
              height={800}
              className="size-10 rounded-full"
            />
          </div>
        ) : (
          <div className="hidden sm:flex justify-center align-middle items-center gap-4">
            <Button
              className="bg-high  text-lg  my-4 hover:cursor-pointer"
              onClick={() => router.push("/login")}
            >
              SignIn
            </Button>

            <Button
              className="text-lg  my-4 hover:cursor-pointer "
              onClick={() => router.push("/signup")}
            >
              SignUp
            </Button>
          </div>
        )}

        {/* Mobile desing  */}

        <div
          onClick={() => handlonClickSidebar()}
          className="navbar_in_phone sm:hidden"
        >
          {open ? (
            <div>
              {" "}
              <SidebarClose size={35} color="#b78bf2" />
            </div>
          ) : (
            <SidebarOpen size={35} color="#b78bf2" />
          )}
        </div>
        <AnimatePresence>
          {open && (
            <motion.div
              initial={{ x: "100%" }}
              animate={{ x: 0 }}
              exit={{
                x: "100%",
                transition: {
                  duration: 0.5,
                  ease: "easeInOut",
                },
              }}
              className="fixed top-20 right-0 w-64 bg-background backdrop-blur-lg h-[calc(100vh-5rem)] sm:hidden overflow-y-auto z-50 shadow-lg flex flex-col"
            >
              {NavItems_Not_loggedin.map((nav, id) => (
                <Link
                  key={id}
                  href={nav.link}
                  className="hover:text-high text-lg w-full  border-b h-14 flex justify-start p-5 align-middle items-center"
                >
                  {nav.name}
                </Link>
              ))}
              <div className="flex justify-start gap-5 p-5">
                <Button
                  className="bg-high  text-lg  my-4 "
                  onClick={() => router.push("/login")}
                >
                  SignIn
                </Button>

                <Button
                  className="text-lg  my-4 "
                  onClick={() => router.push("/signup")}
                >
                  SignUp
                </Button>
              </div>
            </motion.div>
          )}
        </AnimatePresence>
      </MaxWidthWrapper>
    </div>
  );
};

export default Navbar;
